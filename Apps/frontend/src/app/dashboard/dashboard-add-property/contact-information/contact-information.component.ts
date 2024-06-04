import { Component, EventEmitter, Input, Output } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import ValidatorCheckerService from 'services/validatorChecker.service';

@Component({
  selector: 'app-contact-information',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './contact-information.component.html',
  styleUrl: './contact-information.component.css'
})
export class ContactInformationComponent {
  @Input()
  addPropertyForm!: FormGroup;
  @Input()
  isSubmitted!: boolean;

  @Output()
  submit = new EventEmitter();

  constructor(public validatorChecker: ValidatorCheckerService) { }

  submitForm(event: Event) {
    event.preventDefault();
    this.submit.emit();
  }

  get contactPhone(): AbstractControl {
    return this.addPropertyForm.get('contactPhone') ?? new FormControl();
  }
}
