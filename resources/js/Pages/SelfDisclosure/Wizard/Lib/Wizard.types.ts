export interface ExperienceFormData {
    type: 'work' | 'pet'
    time?: 'years' | 'since'
    animal_type: 'dog' | 'cat' | 'other'
    years?: number
    since?: string
}
