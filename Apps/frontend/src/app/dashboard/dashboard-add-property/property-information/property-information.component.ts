import { Component, Input } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import validatorsCheckerService from 'services/validatorChecker.service';

@Component({
  selector: 'app-property-information',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './property-information.component.html',
  styleUrl: './property-information.component.css'
})
export class PropertyInformationComponent {
  @Input()
  addPropertyForm!: FormGroup;
  @Input()
  isSubmitted!: boolean;

  fileName = "";

  constructor(public validatorChecker: validatorsCheckerService) { }

  fileChange(event: Event) {
    const file = (event.currentTarget as HTMLInputElement)?.files?.[0];
    if (file) {
      this.fileName = file.name;
      this.addPropertyForm.patchValue({ images: file });
    }
  }

  get description(): AbstractControl {
    return this.addPropertyForm.get('description') ?? new FormControl();
  }

  get images(): AbstractControl {
    return this.addPropertyForm.get('images') ?? new FormControl();
  }

  get title(): AbstractControl {
    return this.addPropertyForm.get('title') ?? new FormControl();
  }
}
