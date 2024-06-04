import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { Utils } from 'services/utils.service';

@Component({
  selector: 'app-dashboard-layout',
  standalone: true,
  imports: [RouterModule, HeaderComponent, SidebarComponent, FooterComponent],
  templateUrl: './dashboard-layout.component.html',
  styleUrl: './dashboard-layout.component.css'
})
export class DashboardLayoutComponent {
  constructor(public utils: Utils) { }
}
