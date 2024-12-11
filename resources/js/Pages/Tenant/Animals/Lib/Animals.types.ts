interface AnimalFormData {
    name: string
    date_of_birth: string
    sex: 'male' | 'female'
    family?: string | null
    mother?: string | null
    father?: string | null
    bio: string
    abstract: string
    images: (string | File)[]

    _method?: string
}

export interface DogFormData extends AnimalFormData {
    breed: string
}

export interface CatFormData extends AnimalFormData {
    breed: string
}
