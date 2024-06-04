import { Component, Renderer2, OnInit, Inject } from '@angular/core';
import { CommonModule, DOCUMENT } from '@angular/common';

@Component({
    selector: 'app-banner',
    standalone: true,
    imports: [],
    templateUrl: './banner.component.html',
    styleUrl: './banner.component.css'
})
export class BannerComponent {
    constructor(
        private _renderer2: Renderer2,
        @Inject(DOCUMENT) private _document: Document
    ) { }

    ngOnInit(): void {
        let divElement: HTMLElement = this._document.createElement("div");
        divElement.innerHTML = `<div class="home3-banner-area">
    <div class="swiper home3-banner-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="banner-bg"
                    style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.35) 100%), url(assets/img/home/home3-banner-img-1.png);">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="banner-bg"
                    style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.35) 100%), url(assets/img/home/home3-banner-img-2.png);">
                </div>
            </div>
            <div class="swiper-slide">
                <div class="banner-bg"
                    style="background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.35) 100%), url(assets/img/home/home3-banner-img-4.png);">
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-wrapper">
                    <div class="banner-content">
                        <h1>Propriétés de Prestige</h1>
                        <!-- <div class="banner-feature">
                            <ul>
                                <li>Maison Totale <span>23, 855</span></li>
                                <li>En Cours <span>19, 230</span></li>
                                <li>Complété <span>2, 230</span></li>
                                <li>Nouveau Projet <span>2, 230</span></li>
                            </ul>
                        </div> -->
                        <div class="trustpilot-review">
                            <strong>Excellent!</strong>
                            <img src="assets/img/home/icon/trustpilot-star2.svg" alt>
                            <p>5.0 Note sur <strong>5.0</strong> Basé sur <a href="#"><strong>1</strong>
                                    avis</a></p>
                            <img src="assets/img/home/icon/trustpilot-logo2.svg" alt>
                        </div>
                    </div>
                    <div class="slider-btn-group style-2 style-3 justify-content-md-end justify-content-center gap-4">
                        <div class="slider-btn prev-4 d-md-flex d-none">
                            <svg width="11" height="19" viewBox="0 0 8 13" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 6.50008L8 0L2.90909 6.50008L8 13L0 6.50008Z"></path>
                            </svg>
                        </div>
                        <div class="paginations111"></div>
                        <div class="slider-btn next-4 d-md-flex d-none">
                            <svg width="11" height="19" viewBox="0 0 8 13" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 6.50008L0 0L5.09091 6.50008L0 13L8 6.50008Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`;
        // script.type = `application/ld+json`;

        if (!this._document.querySelector(".home3-banner-area")) {

            this._document.querySelector("app-banner")?.appendChild(divElement);
        }
    }
}
