import { HttpContextToken, HttpInterceptorFn } from "@angular/common/http";
import { TOKEN_LOCALSTORAGE_KEY } from "app/config/keys";

export const BYPASS_LOGIN = new HttpContextToken(() => false);

export const authInterceptor: HttpInterceptorFn = (request, next) => {


    if (request.context.get(BYPASS_LOGIN) === false) {
        const token = localStorage.getItem(TOKEN_LOCALSTORAGE_KEY) ?? '';

        request = request.clone({
            setHeaders: {
                'Authorization': token ? `Bearer ${token}` : ''
            }
        });
    }

    return next(request);
}