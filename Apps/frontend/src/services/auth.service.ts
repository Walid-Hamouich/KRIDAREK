import { HttpClient, HttpContext } from "@angular/common/http";
import { Injectable, signal } from "@angular/core";
import { TOKEN_LOCALSTORAGE_KEY } from "app/config/keys";
import { UserInterface } from "models/user/user.interface";
import UserLoginInterface from "models/user/userlogin.interface";
import CurrentUserService from "./currentuser.service";
import UserRegisterInterface from "models/user/userregister.interface";
import { BYPASS_LOGIN } from "interceptors/auth.interceptor";
import { catchError, throwError } from "rxjs";

interface LoginParamsInteface {
    user: UserLoginInterface
    successCallback?: (response?: any) => void
    errorCallback?: (error?: any) => void
}

interface RegisterParamsInterface {
    user: UserRegisterInterface
    successCallback?: () => void
    errorCallback?: () => void
}

@Injectable({
    providedIn: 'root',
})
export default class AuthService {

    constructor(private httpClient: HttpClient, private currentUserService: CurrentUserService) { }

    public loading: boolean = true;

    public checkToken() {
        if (typeof window === 'undefined') return;
        if (!this.loading) {
            return;
        }
        if (!localStorage[TOKEN_LOCALSTORAGE_KEY]) { return; }
        this.loading = true;
        this.httpClient.get('http://localhost:9000/api/users/check')
            .subscribe({
                next: (response: any) => {
                    this.currentUserService.currentUser.set(response);
                    this.loading = false;
                }, error: () => {
                    this.currentUserService.currentUser.set(null);
                    this.loading = false;
                }
            });
    }

    public checkTokenGuard() {
        if (typeof window === 'undefined') return;
        if (!localStorage[TOKEN_LOCALSTORAGE_KEY]) { return false; }
        if (!this.loading && this.currentUserService.currentUser() != null) {
            return true;
        }

        return this.httpClient.get('http://localhost:9000/api/users/check')
            .pipe(
                catchError((err, observable) => {
                    return throwError(err);
                })
            );
    }

    public login({ user, successCallback, errorCallback }: LoginParamsInteface) {
        // TODO: REPLACE THIS HARD CODED CONDITION WITH AN API CALL
        this.httpClient.post('http://localhost:9000/api/login', {
            username: user.email,
            password: user.password
        })
            .subscribe({
                next: (response: any) => {
                    if (response["token"]) {
                        localStorage.setItem(TOKEN_LOCALSTORAGE_KEY, response["token"]);
                        const connectedUser: UserInterface = response["user"];
                        this.currentUserService.currentUser.set(connectedUser);
                        successCallback?.(response);
                    }
                }, error: errorCallback
            });
    }

    public register({ user, successCallback, errorCallback }: RegisterParamsInterface) {
        this.httpClient.post('http://localhost:9000/api/users', {
            ...user
        }, {
            context: new HttpContext().set(BYPASS_LOGIN, true),
            headers: {
                'Content-Type': 'application/ld+json'
            }
        }).subscribe({
            next: (response: Object) => {
                successCallback?.();
            }, error: (err: any) => {
                errorCallback?.();
            }
        });
    }

    public logout(callback?: () => void) {
        localStorage.removeItem(TOKEN_LOCALSTORAGE_KEY);
        this.currentUserService.currentUser.set(null);
        callback?.();
    }
}