interface AnimalFormData {
    name: string
    date_of_birth: string
    bio: string
    abstract: string
}

export interface DogFormData extends AnimalFormData {
    breed: string
}

export interface CatFormData extends AnimalFormData {
    breed: string
}
