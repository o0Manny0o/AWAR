export interface ExperienceFormData {
    type: 'work' | 'pet'
    time?: 'years' | 'since'
    animal_type: 'dog' | 'cat' | 'other'
    years?: number
    since?: string
}

export interface EligibilityFormData {
    animal_protection_experience: boolean
    can_cover_expenses: boolean
    can_cover_emergencies: boolean
    can_afford_insurance: boolean
    can_afford_castration: boolean
    substitute: string
    time_alone_daily: number
}

export interface AnimalSpecificFormData {
    dogs: boolean
    dog_habitat?: 'home' | 'garden' | 'other'
    dog_school?: boolean
    dog_time_to_occupy?: boolean
    dog_purpose?: 'work' | 'pet' | 'breeding' | 'other'

    cats: boolean
    cat_habitat?: 'indoor' | 'outdoor' | 'both'
    cat_house_secure?: boolean
    cat_sleeping_place?: string
    cat_streets_safe?: boolean
    cat_flap_available?: boolean
}

export interface DogSpecificData {
    dogs: boolean
    habitat: 'home' | 'garden' | 'other'
    dog_school: boolean
    time_to_occupy: boolean
    purpose: 'work' | 'pet' | 'breeding' | 'other'
}

export interface CatSpecificData {
    cats: boolean
    habitat: 'indoor' | 'outdoor' | 'both'
    house_secure?: boolean
    sleeping_place?: string
    streets_safe?: boolean
    cat_flap_available?: boolean
}
