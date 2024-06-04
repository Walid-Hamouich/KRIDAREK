import { DOCUMENT } from '@angular/common';
import { Component, Inject, ViewChild } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import UserLoginInterface from 'models/user/userlogin.interface';
import AuthService from 'services/auth.service';

@Component({
  selector: 'app-login-modal',
  standalone: true,
  imports: [RouterLink, ReactiveFormsModule],
  templateUrl: './login-modal.component.html',
  styleUrl: './login-modal.component.css'
})
export class LoginModalComponent {

  @ViewChild("btnClose") btnClose: any;

  isSubmitted: boolean = false;

  errorMessage: string = '';

  constructor(public authService: AuthService, private router: Router) { }

  loginForm = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', Validators.required)
  });

  get email() {
    return this.loginForm.get('email');
  }

  get password() {
    return this.loginForm.get('password');
  }

  submitForm() {
    if (this.loginForm.valid) {
      this.loginForm.disable();
      const user: UserLoginInterface = {
        email: this.email?.value ?? '',
        password: this.password?.value ?? ''
      }
      this.authService.login({
        user,
        successCallback: () => {
          this.errorMessage = '';
          this.btnClose.nativeElement.click();
          this.router.navigate(['/dashboard']);
          this.loginForm.enable();
        },
        errorCallback: (response) => {
          if (response.error.message === "Invalid credentials.") {
            this.errorMessage = "Les informations d'identification fournies sont incorrectes!";
          } else {
            this.errorMessage = response.error.detail;
          }
          this.loginForm.enable();
        }
      });

    }
  }
}
