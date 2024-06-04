import { AbstractControl, ValidationErrors, ValidatorFn } from "@angular/forms";

export const passwordMatchingValidator: ValidatorFn =
    (control: AbstractControl): ValidationErrors | null => {
        const password = control.get('password')?.value ?? '';
        const confirmPassword = control.get('confirmPassword')?.value ?? '';

        if (password === confirmPassword) return null;

        return {
            'passwordMatching': true
        }
    }

export const inArrayValidator = (array: any[]) =>
    (control: AbstractControl): ValidationErrors | null => {
        const value = control.value;
        if (array.indexOf(value) === -1) {
            return {
                'inArray': true
            }
        }
        return null;
    }