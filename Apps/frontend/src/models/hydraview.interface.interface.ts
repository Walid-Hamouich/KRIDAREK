export default interface HydraView {
    "@id": string | undefined
    "@type": string | undefined
    "hydra:totalItems": number,
    "hydra:first": string | undefined
    "hydra:last": string | undefined
    "hydra:next": string | undefined
    "hydra:previous": string | undefined
}