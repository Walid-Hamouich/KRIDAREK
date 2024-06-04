import Property from "./property.interface"
import { UserInterface } from "./user/user.interface"

export default interface Announcement {
    id: number
    slug: string
    title: string
    description: string
    price: number
    images: string[]
    status: string
    contactPhone: string
    area: number
    createdAt: string
    publishedBy?: UserInterface
    property: Property
}