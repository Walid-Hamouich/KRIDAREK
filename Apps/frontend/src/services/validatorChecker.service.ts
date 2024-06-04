import { Injectable } from "@angular/core";
import { AbstractControl } from "@angular/forms";

@Injectable({ providedIn: 'root' })
export default class ValidatorCheckerService {
    checkFormControlInitialError(control: AbstractControl | null, hasSubmitted: boolean = false) {
        return control?.invalid && (control?.dirty || control?.touched || hasSubmitted)
    }
    checkFormControlError(control: AbstractControl | null, errorName: string) {
        return control?.hasError(errorName);
    }
}