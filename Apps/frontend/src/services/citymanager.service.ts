import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { API_ENDPOINT } from "app/config/constants";

@Injectable({
    providedIn: 'root'
})
export default class CityManager {
    constructor(private httpClient: HttpClient) { }

    loadCities(
        successCallback?: (response?: any) => void,
        errorCallback?: (error?: any) => void
    ) {
        this.httpClient.get(`${API_ENDPOINT}/cities`).subscribe({
            next: successCallback,
            error: errorCallback
        })
    }
}