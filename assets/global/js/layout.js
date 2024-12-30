!(function () {
  "use strict";
  var t, a, e;
  sessionStorage.getItem("defaultAttribute") &&
    ((t = document.documentElement.attributes),
      (a = {}),
      Object.entries(t).forEach(function (t) {
        var e;
        t[1] &&
          t[1].nodeName &&
          "undefined" != t[1].nodeName &&
          ((e = t[1].nodeName), (a[e] = t[1].nodeValue));
      }),
      sessionStorage.getItem("defaultAttribute") !== JSON.stringify(a)
        ? (sessionStorage.clear(), window.location.reload())
        : (((e = {})["data-layout-default"] = sessionStorage.getItem("data-layout-default")),
          (e["data-sidebar-size"] = sessionStorage.getItem("data-sidebar-size")),
          (e["data-layout-default-mode"] = sessionStorage.getItem("data-layout-default-mode")),
          (e["data-layout-default-width"] = sessionStorage.getItem("data-layout-default-width")),
          (e["data-sidebar"] = sessionStorage.getItem("data-sidebar")),
          (e["data-sidebar-image"] =
            sessionStorage.getItem("data-sidebar-image")),
          (e["data-layout-default-direction"] = sessionStorage.getItem(
            "data-layout-default-direction"
          )),
          (e["data-layout-default-position"] = sessionStorage.getItem(
            "data-layout-default-position"
          )),
          (e["data-layout-default-style"] = sessionStorage.getItem("data-layout-default-style")),
          (e["data-topbar"] = sessionStorage.getItem("data-topbar")),
          (e["data-preloader"] = sessionStorage.getItem("data-preloader")),
          (e["data-body-image"] = sessionStorage.getItem("data-body-image")),
          Object.keys(e).forEach(function (t) {
            e[t] && document.documentElement.setAttribute(t, e[t]);
          })));
})();
