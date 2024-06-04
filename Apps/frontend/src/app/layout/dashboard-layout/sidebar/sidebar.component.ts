import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { LogoutBtnComponent } from './logout-btn/logout-btn.component';

@Component({
  selector: 'app-sidebar',
  standalone: true,
  imports: [RouterModule, LogoutBtnComponent],
  templateUrl: './sidebar.component.html',
  styleUrl: './sidebar.component.css'
})
export class SidebarComponent {

}
