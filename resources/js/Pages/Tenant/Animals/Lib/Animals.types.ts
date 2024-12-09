interface AnimalFormData {
    name: string
    date_of_birth: string
    family: { id: string; name: string }
    bio: string
    abstract: string
    images: (string | File)[]
}

export interface DogFormData extends AnimalFormData {
    breed: string
}

export interface CatFormData extends AnimalFormData {
    breed: string
}
