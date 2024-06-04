import { Component } from '@angular/core';
import { ContactPageComponent } from './contact-page/contact-page.component';
import { ContactMapComponent } from './contact-map/contact-map.component';
import { SharedBannerComponent } from 'app/shared/shared-banner/shared-banner.component';

@Component({
  selector: 'app-contact-us',
  standalone: true,
  imports: [SharedBannerComponent, ContactPageComponent, ContactMapComponent],
  templateUrl: './contact-us.component.html',
  styleUrl: './contact-us.component.css'
})
export class ContactUsComponent {

}
