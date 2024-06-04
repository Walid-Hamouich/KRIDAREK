import { Component } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { RouterLink } from '@angular/router';
import UserRegisterInterface from 'models/user/userregister.interface';
import AuthService from 'services/auth.service';
import validatorsCheckerService from 'services/validatorChecker.service';
import { passwordMatchingValidator } from 'utils/customFormValidators';

@Component({
  selector: 'app-signup-modal',
  standalone: true,
  imports: [RouterLink, ReactiveFormsModule],
  templateUrl: './signup-modal.component.html',
  styleUrl: './signup-modal.component.css'
})
export class SignupModalComponent {

  private responseMessage?: string;
  private responseType?: string;

  hasSubmitted = false;

  singUpForm = new FormGroup({
    firstName: new FormControl('', Validators.required),
    lastName: new FormControl('', Validators.required),
    email: new FormControl('', [Validators.required, Validators.email]),
    phoneNumber: new FormControl('', [Validators.required, Validators.pattern(/^0[67]\d{8}$/)]),
    password: new FormControl('', [Validators.required]),
    confirmPassword: new FormControl(''),
  }, { validators: passwordMatchingValidator });

  constructor(
    public validatorChecker: validatorsCheckerService,
    private authService: AuthService
  ) { }

  get firstName() { return this.singUpForm.get('firstName') }
  get lastName() { return this.singUpForm.get('lastName') }
  get email() { return this.singUpForm.get('email') }
  get phoneNumber() { return this.singUpForm.get('phoneNumber') }
  get password() { return this.singUpForm.get('password') }
  get confirmPassword() { return this.singUpForm.get('confirmPassword'); }

  get getResponseMessage() { return this.responseMessage; }
  get getResponseType() { return this.responseType; }

  submit() {
    this.hasSubmitted = true;
    if (this.singUpForm.valid) {
      this.singUpForm.disable();
      const user: UserRegisterInterface = {
        firstName: this.firstName?.value ?? '',
        lastName: this.lastName?.value ?? '',
        email: this.email?.value ?? '',
        password: this.password?.value ?? '',
        phoneNum: this.phoneNumber?.value ?? '',
      }
      this.authService.register({
        user,
        successCallback: () => {
          this.singUpForm.enable();
          this.responseMessage = 'L\'inscription a été faite avec succés!';
          this.responseType = 'success';
        },
        errorCallback: () => {
          this.singUpForm.enable();
          this.responseMessage = 'Une erreur a été rencontrée';
          this.responseType = 'danger';
        }
      });
    }
  }

}
