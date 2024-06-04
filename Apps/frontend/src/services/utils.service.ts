import { DOCUMENT } from "@angular/common";
import { Inject, Injectable } from "@angular/core";

@Injectable()
export class Utils {
    alreadyExecuted = false;

    constructor(@Inject(DOCUMENT) private _document: Document) {

    }

    private codeFromCustomJs(): void {
        const currentLocation = this._document.location.href;
        const menuItem: NodeListOf<HTMLAnchorElement> = this._document.querySelectorAll('ul li a');
        const menuLength = menuItem.length;
        for (let i = 0; i < menuLength; i++) {
            if (menuItem[i].href.toLowerCase().replace('-', ' ') === currentLocation.toLowerCase()) {
                menuItem[i].className = "active";
            }
        }
    }

    counterUp(): void {
        setTimeout(() => {
            const ID = "counterup";
            const script = this._document.createElement("script");
            this._document.querySelector(`#${ID}`)?.remove();
            script.id = ID;
            script.textContent = "$('.counter').counterUp({ delay: 10, time: 1000 })";
            this._document.head.appendChild(script);
        }, 10);

    }

    reExecuteScript(): void {
        Array.from(this._document.querySelectorAll('ul li a.active')).forEach(
            ele => ele.classList.remove('active')
        );
        this._document.head.querySelector("[src*='assets/js/custom.js']")?.remove();
        this._document.head.querySelector("[src*='email-decode.min.js']")?.remove();
        let script = this._document.createElement("script");
        script.src = "/assets/js/custom.js";
        let script2 = this._document.createElement("script");
        script2.src = "/assets/5c5dd728/cloudflare-static/email-decode.min.js";
        this._document.head.append(script, script2);
        // this.codeFromCustomJs();
        if (!this.alreadyExecuted) {
            this.alreadyExecuted = true;
            return;
        }
        var sidebarbutton = (this._document.
            querySelector('.sidebar-button.mobile-menu-btn') as HTMLElement);
        sidebarbutton.classList.contains('active') && sidebarbutton.click();
        // this._document.querySelector(".main-menu.show-menu")?.classList.remove("show-menu");
        // this._document.querySelector(".sidebar-button.mobile-menu-btn.active")?.classList.remove('active');
        const preloaderEle: Element | null = this._document.querySelector(".egns-preloader");
        if (preloaderEle) {
            if (!preloaderEle.hasAttribute('style') || !preloaderEle.classList.contains('close')) {
                preloaderEle.classList.add("close");
            }
        }

    }
}