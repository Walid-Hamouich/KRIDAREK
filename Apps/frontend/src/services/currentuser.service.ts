import { Injectable, signal } from "@angular/core";
import { UserInterface } from "models/user/user.interface";

@Injectable({
    providedIn: 'root'
})
export default class CurrentUserService {
    currentUser = signal<UserInterface | null | undefined>(undefined);
    defaultUser: UserInterface = {
        id: 0,
        email: 'admin@gmail.com',
        firstName: 'ahmed',
        token: '0123456789'
    }

}