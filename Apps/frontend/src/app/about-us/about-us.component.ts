import { Component } from '@angular/core';
import { SharedBannerComponent } from 'app/shared/shared-banner/shared-banner.component';
import { AboutUsSectionComponent } from './about-us-section/about-us-section.component';
import { SharedHowItWorksComponent } from 'app/shared/shared-how-it-works/shared-how-it-works.component';

@Component({
  selector: 'app-about-us',
  standalone: true,
  imports: [SharedBannerComponent, AboutUsSectionComponent, SharedHowItWorksComponent],
  templateUrl: './about-us.component.html',
  styleUrl: './about-us.component.css'
})
export class AboutUsComponent {

}
