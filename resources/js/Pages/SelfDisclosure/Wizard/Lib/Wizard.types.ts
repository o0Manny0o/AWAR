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
