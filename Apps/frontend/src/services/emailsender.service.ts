import { HttpClient, HttpContext } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { BYPASS_LOGIN } from "interceptors/auth.interceptor";


interface EmailFormInterface extends Partial<{
    fullname: string | null,
    from: string | null;
    phoneNumber: string | null;
    subject: string | null;
    message: string | null;
}> {

}

@Injectable({
    providedIn: 'root'
})
export default class EmailSender {
    constructor(private httpClient: HttpClient) { }

    sendEmail({ fullname, from, phoneNumber, subject, message }: EmailFormInterface,
        successCallback?: (success: Object) => void,
        errorCallback?: (err: any) => void
    ) {
        this.httpClient.post('http://localhost:9000/api/contact-us', {
            fullname,
            from,
            phoneNumber,
            subject,
            message
        }, {
            context: new HttpContext().set(BYPASS_LOGIN, true)
        }).subscribe({
            next: (response) => {
                console.log("SUCCESS");
                successCallback?.(response);
            },
            error: (err) => {
                console.error(err.error);
                errorCallback?.(err);
            }
        })

    }
}