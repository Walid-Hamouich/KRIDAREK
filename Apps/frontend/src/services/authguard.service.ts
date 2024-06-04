import { Injectable, inject } from "@angular/core";
import { ActivatedRouteSnapshot, CanActivateFn, Router, RouterStateSnapshot } from "@angular/router";
import { Observable, catchError, filter, map, of, pipe } from "rxjs";
import CurrentUserService from "./currentuser.service";
import { UserInterface } from "models/user/user.interface";
import AuthService from "./auth.service";

@Injectable({
    providedIn: 'root'
})
class AuthGuardService {

    constructor(
        private router: Router,
        private authService: AuthService,
        private currentUserService: CurrentUserService
    ) { }

    canActivate(next: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<boolean> | boolean {
        const checkToken = this.authService.checkTokenGuard();
        if (typeof (checkToken) === "boolean") {
            return checkToken;
        } else {
            return checkToken!.pipe(
                map((response: any) => {
                    this.authService.loading = false;
                    this.currentUserService.currentUser.set(response);
                    return true
                }),
                catchError(err => {
                    this.authService.loading = false;
                    this.currentUserService.currentUser.set(null);
                    this.router.navigate(['/']);
                    return of(false);
                })
            );

        }
        // return this.currentUserService.currentUser() != null;
    }
}
export const AuthGuard: CanActivateFn = (next: ActivatedRouteSnapshot, state: RouterStateSnapshot):
    Observable<boolean> | boolean => {
    return inject(AuthGuardService).canActivate(next, state);
}
export default AuthGuardService;