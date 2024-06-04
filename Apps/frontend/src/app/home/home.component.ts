import { Component } from '@angular/core';
import { BannerComponent } from './banner/banner.component';
import { ProjectLocationComponent } from './project-location/project-location.component';
import { AboutUsSectionComponent } from './about-us-section/about-us-section.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [BannerComponent, ProjectLocationComponent, AboutUsSectionComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {

}
