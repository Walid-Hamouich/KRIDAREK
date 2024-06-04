import { Component } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import EmailSender from 'services/emailsender.service';
import validatorsCheckerService from 'services/validatorChecker.service';

@Component({
  selector: 'app-contact-page',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './contact-page.component.html',
  styleUrl: './contact-page.component.css'
})
export class ContactPageComponent {

  contactUsForm = new FormGroup({
    fullname: new FormControl('', [Validators.required, Validators.pattern(/[^0-9]/)]),
    from: new FormControl('', [Validators.required, Validators.email]),
    phoneNumber: new FormControl('', [Validators.required, Validators.pattern(/^0[678]\d{8}$/)]),
    subject: new FormControl('', [Validators.required]),
    message: new FormControl('', [Validators.required]),
  });

  public responseMsg?: string | null;
  public responseClass!: string;

  constructor(
    private emailSender: EmailSender,
    public validatorsChecker: validatorsCheckerService
  ) {

  }

  get fullname(): AbstractControl<string | null> {
    return this.contactUsForm.get('fullname') || new FormControl();
  }

  get from(): AbstractControl<string | null> {
    return this.contactUsForm.get('from') || new FormControl();
  }

  get phoneNumber(): AbstractControl<string | null> {
    return this.contactUsForm.get('phoneNumber') || new FormControl();
  }

  get subject(): AbstractControl<string | null> {
    return this.contactUsForm.get('subject') || new FormControl();
  }

  get message(): AbstractControl<string | null> {
    return this.contactUsForm.get('message') || new FormControl();
  }

  submit() {
    if (this.contactUsForm.valid) {
      this.responseMsg = null;
      this.contactUsForm.disable();
      this.emailSender.sendEmail(this.contactUsForm.value,
        (success: {
          success_message?: string
        }) => {
          this.contactUsForm.enable();
          if (success.hasOwnProperty('success_message')) {
            this.responseMsg = success['success_message'];
          }
          this.responseClass = "success";

        },
        (err) => {
          this.contactUsForm.enable();
          this.responseMsg = err["error_message"] ?? 'Erreur !';
          this.responseClass = "danger";
        }
      );

    }
  }

}
