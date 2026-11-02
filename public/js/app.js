/* RV CCTV Bali - Admin Application Logic */

// Global utility for toast messages
function showToast(message) {
  let container = document.getElementById("toast-container");
  if (!container) {
    container = document.createElement("div");
    container.id = "toast-container";
    container.className = "toast-container";
    document.body.appendChild(container);
  }

  const toast = document.createElement("div");
  toast.className = "toast";
  toast.textContent = message;
  container.appendChild(toast);

  setTimeout(() => {
    toast.remove();
  }, 2600);
}

// Immediately restore saved sidebar minimized state to prevent layout shift
(function() {
  try {
    if (localStorage.getItem("rv_sidebar_minimized") === "true") {
      document.documentElement.classList.add("sidebar-minimized");
      if (document.body) {
        document.body.classList.add("sidebar-minimized");
      }
    }
  } catch (e) {}
})();

// Sidebar Drawer & Minimize Control
function setupSidebar() {
  const sidebar = document.getElementById("sidebar");
  const toggleBtn = document.getElementById("sidebar-toggle-btn");
  const closeBtn = document.getElementById("sidebar-close-btn");
  const backdrop = document.getElementById("sidebar-overlay") || document.getElementById("sidebar-backdrop");

  if (!sidebar) return;

  // Restore saved minimize state on body
  try {
    if (localStorage.getItem("rv_sidebar_minimized") === "true") {
      document.body.classList.add("sidebar-minimized");
      document.documentElement.classList.add("sidebar-minimized");
    }
  } catch (err) {}

  // Auto-populate data-tooltip for all nav links & parent buttons
  sidebar.querySelectorAll(".sidebar-nav-link, .sidebar-nav-parent").forEach((link) => {
    if (!link.getAttribute("data-tooltip")) {
      const span = link.querySelector("span");
      if (span) {
        link.setAttribute("data-tooltip", span.textContent.trim());
      }
    }
  });

  function updateToggleBtnState(isMin) {
    if (toggleBtn) {
      toggleBtn.title = isMin ? "Expand Sidebar (Ctrl+B)" : "Collapse Sidebar (Ctrl+B)";
      toggleBtn.setAttribute("aria-label", isMin ? "Expand Sidebar" : "Collapse Sidebar");
    }
  }

  function toggleSidebarMinimize() {
    const isMinimized = document.body.classList.toggle("sidebar-minimized");
    document.documentElement.classList.toggle("sidebar-minimized", isMinimized);
    try {
      localStorage.setItem("rv_sidebar_minimized", isMinimized ? "true" : "false");
    } catch (err) {}
    updateToggleBtnState(isMinimized);
    showToast(isMinimized ? "Sidebar collapsed." : "Sidebar expanded.");
  }

  updateToggleBtnState(document.body.classList.contains("sidebar-minimized"));

  function openMobileDrawer() {
    sidebar.classList.add("open");
    if (backdrop) backdrop.classList.add("active");
  }

  function closeMobileDrawer() {
    sidebar.classList.remove("open");
    if (backdrop) backdrop.classList.remove("active");
  }

  if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
      if (window.innerWidth <= 1024) {
        if (sidebar.classList.contains("open")) {
          closeMobileDrawer();
        } else {
          openMobileDrawer();
        }
      } else {
        toggleSidebarMinimize();
      }
    });
  }

  if (closeBtn) closeBtn.addEventListener("click", closeMobileDrawer);
  if (backdrop) backdrop.addEventListener("click", closeMobileDrawer);

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && sidebar.classList.contains("open")) {
      closeMobileDrawer();
    }
    // Keyboard shortcut: Ctrl + B or Cmd + B to toggle minimize
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === "b" && !e.target.matches("input, textarea, select")) {
      e.preventDefault();
      if (window.innerWidth > 1024) {
        toggleSidebarMinimize();
      }
    }
  });

  // When clicking parent nav in minimized mode, expand sidebar and open submenu
  sidebar.querySelectorAll(".sidebar-nav-parent").forEach((parentBtn) => {
    parentBtn.addEventListener("click", () => {
      if (document.body.classList.contains("sidebar-minimized")) {
        toggleSidebarMinimize();
      }
    });
  });
}

// Setup Submenu Accordions
function setupSubmenus() {
  document.querySelectorAll(".sidebar-nav-parent").forEach((parentBtn) => {
    parentBtn.addEventListener("click", () => {
      const targetId = parentBtn.getAttribute("data-target");
      const targetMenu = document.getElementById(targetId);
      if (!targetMenu) return;

      const isOpen = targetMenu.classList.contains("open");
      if (isOpen) {
        targetMenu.classList.remove("open");
        parentBtn.classList.remove("open");
      } else {
        targetMenu.classList.add("open");
        parentBtn.classList.add("open");
      }
    });
  });
}

// Auto-initialize DataTables on DOM Ready
function initDataTables() {
  if (window.jQuery && window.jQuery.fn.DataTable) {
    window.jQuery("table.data-table").each(function() {
      if (!window.jQuery.fn.DataTable.isDataTable(this)) {
        window.jQuery(this).DataTable({
          responsive: true,
          pageLength: 10,
          language: {
            search: "_INPUT_",
            searchPlaceholder: "Search table records...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No records found",
            zeroRecords: "No matching records found",
            paginate: {
              first: "«",
              previous: "‹",
              next: "›",
              last: "»"
            }
          }
        });
      }
    });
  }
}

// Auto-initialize Select2 on DOM Ready
function initSelect2() {
  if (window.jQuery && window.jQuery.fn.select2) {
    window.jQuery("select.select2").each(function() {
      const selectElement = window.jQuery(this);
      if (selectElement.hasClass("select2-hidden-accessible")) {
        return;
      }
      const placeholderText = selectElement.attr("data-placeholder") || "Select an option";
      const isMultiple = selectElement.prop("multiple");

      selectElement.select2({
        theme: "bootstrap-5",
        width: "100%",
        placeholder: placeholderText,
        allowClear: !isMultiple,
        closeOnSelect: !isMultiple
      });
    });
  }
}

// Auto-initialize SweetAlert2 Delete Confirmation (Delegated for DataTables support)
function initDeleteConfirmations() {
  document.addEventListener("submit", (submitEvent) => {
    const formElement = submitEvent.target.closest("form.delete-confirm-form");
    if (!formElement) {
      return;
    }

    if (formElement.dataset.confirmed === "true") {
      return;
    }

    submitEvent.preventDefault();

    const confirmTitle = formElement.getAttribute("data-confirm-title") || "Are you sure?";
    const confirmText = formElement.getAttribute("data-confirm-text") || "Are you sure you want to delete this record? This action cannot be undone.";

    if (typeof window.Swal !== "undefined") {
      window.Swal.fire({
        title: confirmTitle,
        text: confirmText,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc2626",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        reverseButtons: true
      }).then((resultObj) => {
        if (resultObj.isConfirmed) {
          formElement.dataset.confirmed = "true";
          formElement.submit();
        }
      });
    } else if (window.confirm(confirmText)) {
      formElement.dataset.confirmed = "true";
      formElement.submit();
    }
  });
}

// Auto-initialize TinyMCE on DOM Ready
function initTinyMce() {
  if (typeof window.tinymce !== "undefined" && document.querySelector("textarea.tinymce-editor")) {
    window.tinymce.init({
      selector: "textarea.tinymce-editor",
      base_url: "/js/tinymce",
      suffix: ".min",
      license_key: "gpl",
      height: 280,
      menubar: false,
      branding: false,
      promotion: false,
      plugins: "lists link table code wordcount",
      toolbar: "undo redo | blocks | bold italic underline | bullist numlist | link table | removeformat code",
      setup: (editorInstance) => {
        editorInstance.on("change input undo redo", () => {
          editorInstance.save();
        });
      }
    });
  }
}

// Initialization on DOM Ready
document.addEventListener("DOMContentLoaded", () => {
  setupSidebar();
  setupSubmenus();
  initDataTables();
  initSelect2();
  initDeleteConfirmations();
  initTinyMce();
});
