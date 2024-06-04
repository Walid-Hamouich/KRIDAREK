import { Location } from '@angular/common';
import { Component } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { LoginModalComponent } from 'app/shared/login-modal/login-modal.component';
import { SearchBarComponent } from 'app/shared/search-bar/search-bar.component';
import { SignupModalComponent } from 'app/shared/signup-modal/signup-modal.component';
import AuthService from 'services/auth.service';
import CurrentUserService from 'services/currentuser.service';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [RouterLink, SignupModalComponent, LoginModalComponent, SearchBarComponent],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {
  constructor(
    public currentUserService: CurrentUserService,
    private authService: AuthService,
    public router: Router) {
  }
}
