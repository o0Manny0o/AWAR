interface AnimalFormData {
    name: string
    date_of_birth: string
    bio: string
    abstract: string
    images: any[]
}

export interface DogFormData extends AnimalFormData {
    breed: string
}

export interface CatFormData extends AnimalFormData {
    breed: string
}
