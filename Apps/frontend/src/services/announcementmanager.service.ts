import { HttpClient, HttpContext } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { API_ENDPOINT } from "app/config/constants";
import { response } from "express";
import { BYPASS_LOGIN } from "interceptors/auth.interceptor";
import Status from "models/status.enum";

interface AddAnnouncementInterface {
    property: {
        type: string
        action: string
        cityId: string
    }
    title: string
    description: string
    area: number
    price: number
    images: File
    publishedById: number,
    contactPhone: string
}


@Injectable({
    providedIn: 'root'
})


export default class AnnouncementManagerService {
    constructor(private httpClient: HttpClient) {

    }

    loadAnnouncementsCount(
        publishedById: number,
        successCallback?: (response?: any) => void,
        errorCallback?: (error?: any) => void
    ) {
        this.httpClient.get(
            `http://localhost:9000/api/announcements/_/count?publishedBy.id=${publishedById}`)
            .subscribe({
                next: successCallback,
                error: errorCallback
            });
    }

    loadAnnouncementsCountByStatus(
        publishedById: number,
        status: Status,
        successCallback?: (response?: any) => void,
        errorCallback?: (error?: any) => void
    ) {
        this.httpClient.get(
            `${API_ENDPOINT}/announcements/_/count?publishedBy.id=${publishedById
            }&status=${status
            }`
        )
            .subscribe({
                next: successCallback,
                error: errorCallback
            });
    }

    // loadAnnouncementsByCity(
    //     city: string,
    //     successCallback?: (response?: any) => void,
    //     errorCallback?: (error?: any) => void
    // ) {
    //     this.httpClient.get(`${API_ENDPOINT}/announcements/?property.city.label=${city}`)
    //         .subscribe({
    //             next: successCallback,
    //             error: errorCallback
    //         });
    // }

    addAnnouncement(
        {
            title,
            description,
            price,
            contactPhone,
            area,
            images,
            publishedById,
            property,
        }: AddAnnouncementInterface,
        successCallback?: (response?: any) => void,
        errorCallback?: (response?: any) => void
    ) {
        this.httpClient.post(`${API_ENDPOINT}/properties`, {
            "type": property.type,
            "action": property.action,
            "city": `/api/cities/${property.cityId}`
        }, {
            headers: {
                'Content-Type': 'application/ld+json'
            }
        }).subscribe({
            next: (response: any) => {
                const propertyId = response["id"];
                const formData = new FormData();
                formData.append("title", title);
                formData.append("description", description);
                formData.append("price", price.toString());
                formData.append("area", area.toString());
                formData.append("contactPhone", contactPhone);
                formData.append("images[]", images);
                formData.append("publishedById", `${publishedById}`);
                formData.append("propertyId", propertyId);
                this.httpClient.post(`${API_ENDPOINT}/announcements`, formData, {

                }).subscribe({
                    next: (response) => {
                        successCallback?.(response);
                    },
                    error: errorCallback
                });
            },
            error: errorCallback
        })
    }

    loadOneAnnouncementById(
        id: number,
        successCallback?: (response?: any) => void,
        errorCallback?: (error?: any) => void
    ) {
        this.httpClient.get(`${API_ENDPOINT}/announcements/${id}`, {
            context: new HttpContext().set(BYPASS_LOGIN, true)
        }).
            subscribe({
                next: successCallback,
                error: errorCallback
            })
    }

    deleteAnnouncement(
        id: number,
        successCallback?: (response?: any) => void,
        errorCallback?: (error?: any) => void
    ) {
        this.httpClient.patch(`${API_ENDPOINT}/announcements/${id}`, {
            status: Status.DELETED
        }, {
            headers: {
                'Content-Type': 'application/merge-patch+json'
            }
        })
            .subscribe({
                next: successCallback,
                error: errorCallback
            });
    }
}