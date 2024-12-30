"use strict"



// Header Sticky
window.addEventListener("scroll", function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const header = document.querySelector(".header");
    if (header) {
        header.classList.toggle("header_sticky", scrollTop > 0);
    }
});

// Tabs 
const triggerTabList = document.querySelectorAll('#myTab .nav-link')
triggerTabList.forEach(triggerEl => {
    const tabTrigger = new bootstrap.Tab(triggerEl)
    triggerEl.addEventListener('click', event => {
        event.preventDefault()
        tabTrigger.show()
    })
})

// Document mobile side bar
const docuSidebarBtn = document.querySelector(".docu-menu-btn")
const documentSidebar = document.querySelector(".document-sidebar");
if (documentSidebar != null && docuSidebarBtn != null) {
    const documentLeft = documentSidebar.querySelector(".document-left");
    const closeDocument = documentSidebar.querySelector(".close-document-menu");
    const documentOverlay = documentSidebar.querySelector(".document-overlay");
    docuSidebarBtn.addEventListener("click", () => {
        documentLeft.classList.add("show-document-left")
        documentSidebar.classList.add("show-document-sidebar")
        documentOverlay.style.display = "block"
        if (documentSidebar.classList.contains("show-document-sidebar")) {
            documentOverlay.addEventListener("click", () => {
                documentLeft.classList.remove("show-document-left")
                documentSidebar.classList.remove("show-document-sidebar")
                documentOverlay.style.display = "none"
            })
            closeDocument.addEventListener("click", () => {
                documentLeft.classList.remove("show-document-left")
                documentSidebar.classList.remove("show-document-sidebar")
                documentOverlay.style.display = "none"
            })
        }
    })
}

// mobile menu side bar
const menuBtn = document.querySelector(".bars")
const mainNav = document.querySelector(".main-nav");

if (mainNav != null) {
    const navMenu = mainNav.querySelector(".nav-menu-wrap");
    const closeSidebar = mainNav.querySelector(".close-sidebar");
    const overlay = mainNav.querySelector(".main-nav-overlay");

    menuBtn.addEventListener("click", () => {
        navMenu.classList.add("show-menu-wrap")
        mainNav.classList.add("show-main-nav")
        overlay.style.display = "block"
        if (mainNav.classList.contains("show-main-nav")) {
            overlay.addEventListener("click", () => {
                navMenu.classList.remove("show-menu-wrap")
                mainNav.classList.remove("show-main-nav")
                overlay.style.display = "none"
            })
            closeSidebar.addEventListener("click", () => {
                navMenu.classList.remove("show-menu-wrap")
                mainNav.classList.remove("show-main-nav")
                overlay.style.display = "none"
            })
        }
    })
}

$(function () {

    $(document).on('click', '.close', function (e) {
        $(this).closest('.modal').modal('hide');
    })
    var Accordion = function (el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;

        // Variables privadas
        var links = this.el.find('.link');
        // Evento
        links.on('click', { el: this.el, multiple: this.multiple }, this.dropdown)
    }

    Accordion.prototype.dropdown = function (e) {
        var $el = e.data.el;
        $this = $(this),
            $next = $this.next();

        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
            $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
        };
    }

    var accordion = new Accordion($('#accordion'), false);
});


// Collapse Menu
if (document.querySelectorAll(".document-menu .collapse")) {
    var collapses = document.querySelectorAll(".document-menu .collapse");
    Array.from(collapses).forEach(function (collapse) {

        var collapseInstance = new bootstrap.Collapse(collapse, {
            toggle: false,
        });

        collapse.addEventListener("show.bs.collapse", function (e) {
            e.stopPropagation();
            var closestCollapse = collapse.parentElement.closest(".collapse");
            if (closestCollapse) {
                var siblingCollapses = closestCollapse.querySelectorAll(".collapse");
                Array.from(siblingCollapses).forEach(function (siblingCollapse) {
                    var siblingCollapseInstance =
                        bootstrap.Collapse.getInstance(siblingCollapse);
                    if (siblingCollapseInstance === collapseInstance) {
                        return;
                    }
                    siblingCollapseInstance.hide();
                });
            } else {
                var getSiblings = function (elem) {
                    var siblings = [];
                    var sibling = elem.parentNode.firstChild;

                    while (sibling) {
                        if (sibling.nodeType === 1 && sibling !== elem) {
                            siblings.push(sibling);
                        }
                        sibling = sibling.nextSibling;
                    }
                    return siblings;
                };

                var siblings = getSiblings(collapse.parentElement);
                Array.from(siblings).forEach(function (item) {
                    if (item.childNodes.length > 2)
                        item.firstElementChild.setAttribute("aria-expanded", "false");
                    var ids = item.querySelectorAll("*[id]");
                    Array.from(ids).forEach(function (item1) {
                        item1.classList.remove("show");
                        if (item1.childNodes.length > 2) {
                            var val = item1.querySelectorAll("ul li a");
                            Array.from(val).forEach(function (subitem) {
                                if (subitem.hasAttribute("aria-expanded"))
                                    subitem.setAttribute("aria-expanded", "false");
                            });
                        }
                    });
                });
            }
        });

        // Hide nested collapses on `hide.bs.collapse`
        collapse.addEventListener("hide.bs.collapse", function (e) {
            e.stopPropagation();
            var childCollapses = collapse.querySelectorAll(".collapse");
            Array.from(childCollapses).forEach(function (childCollapse) {
                childCollapseInstance = bootstrap.Collapse.getInstance(childCollapse);
                childCollapseInstance.hide();
            });
        });
    });
}
