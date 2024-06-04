import { Component } from '@angular/core';
import { BannerComponent } from './banner/banner.component';
import { ProjectLocationComponent } from './project-location/project-location.component';
import { AboutUsSectionComponent } from './about-us-section/about-us-section.component';
import { FeaturedProjectsComponent } from './featured-projects/featured-projects.component'

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [BannerComponent, ProjectLocationComponent, AboutUsSectionComponent, FeaturedProjectsComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {

}
