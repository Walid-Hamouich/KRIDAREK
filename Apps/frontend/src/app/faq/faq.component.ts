import { Component } from '@angular/core';
import { FAQPageComponent } from './faq-page/faq-page.component';
import { SharedBannerComponent } from 'app/shared/shared-banner/shared-banner.component';

@Component({
  selector: 'app-faq',
  standalone: true,
  imports: [SharedBannerComponent, FAQPageComponent],
  templateUrl: './faq.component.html',
  styleUrl: './faq.component.css'
})
export class FAQComponent {

}
