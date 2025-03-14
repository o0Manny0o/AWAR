import Animal = App.Models.Animal

interface ListingFormData {
    excerpt: string
    description: string
    animals: Animal[]
    images: number[]
}
