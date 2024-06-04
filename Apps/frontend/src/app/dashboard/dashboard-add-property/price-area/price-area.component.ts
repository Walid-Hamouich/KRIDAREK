import { Component, Input } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import ValidatorCheckerService from 'services/validatorChecker.service';

@Component({
  selector: 'app-price-area',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './price-area.component.html',
  styleUrl: './price-area.component.css'
})
export class PriceAreaComponent {
  @Input()
  addPropertyForm!: FormGroup;
  @Input()
  isSubmitted!: boolean;

  constructor(public validatorChecker: ValidatorCheckerService) { }

  get price(): AbstractControl {
    return this.addPropertyForm.get('price') ?? new FormControl();
  }

  get area(): AbstractControl {
    return this.addPropertyForm.get('area') ?? new FormControl();
  }

}
