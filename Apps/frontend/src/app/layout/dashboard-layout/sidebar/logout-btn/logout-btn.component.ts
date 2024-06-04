import { Component } from '@angular/core';
import { Router } from '@angular/router';
import AuthService from 'services/auth.service';

@Component({
  selector: 'app-logout-btn',
  standalone: true,
  imports: [],
  templateUrl: './logout-btn.component.html',
  styleUrl: './logout-btn.component.css'
})
export class LogoutBtnComponent {

  constructor(private authService: AuthService, private router: Router) { }

  logout() {
    this.authService.logout(() => this.router.navigate(['/']));
  }
}
