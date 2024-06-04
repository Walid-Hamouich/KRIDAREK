import { Component, Input } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import City from 'models/city.interface';
import validatorsCheckerService from 'services/validatorChecker.service';

@Component({
  selector: 'app-property-location',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './property-location.component.html',
  styleUrl: './property-location.component.css'
})
export class PropertyLocationComponent {
  @Input()
  addPropertyForm!: FormGroup;
  @Input()
  isSubmitted!: boolean;
  @Input()
  types: string[] = []
  @Input()
  cities!: City[];


  constructor(public validatorChecker: validatorsCheckerService) { }

  get type(): AbstractControl {
    return this.addPropertyForm.get('type') ?? new FormControl();
  }

  get action(): AbstractControl {
    return this.addPropertyForm.get('action') ?? new FormControl();
  }

  get city(): AbstractControl {
    return this.addPropertyForm.get('city') ?? new FormControl();
  }
}
