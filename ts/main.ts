import { MetaStaff } from "./metabox/staff";

(() => {
  const buttonToggle = document.querySelectorAll(".menu-toggle");
  const menu = document.querySelector<HTMLDivElement>(".main-navigation");
  const body = document.querySelector("body");

  buttonToggle.forEach((button) => {
    button.addEventListener("click", () => {
      if(menu){
        if(!menu.classList.contains("show")){
          body?.classList.add("no-scroll");
          menu.classList.add("show");
        } else {
          menu.classList.add("hide");
        }
      }
    });
  });
  menu?.addEventListener("animationend", (e) => {
    if(e.animationName === "fade-out"){
      menu.classList.remove("hide");
      menu.classList.remove("show");
      body?.classList.remove("no-scroll");
    }
  });
})();

// @ts-ignore
globalThis.MetaStaff = MetaStaff;