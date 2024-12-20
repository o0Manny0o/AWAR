import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

type WizardFormContextData = {
    name: RefObject<HTMLInputElement>
    year: RefObject<HTMLInputElement>
    profession: RefObject<HTMLInputElement>
    knows_animals: RefObject<HTMLButtonElement>

    street_address: RefObject<HTMLInputElement>
    locality: RefObject<HTMLInputElement>
    region: RefObject<HTMLInputElement>
    postal_code: RefObject<HTMLInputElement>
    country: RefObject<HTMLInputElement>

    move_in_date: RefObject<HTMLInputElement>
    size: RefObject<HTMLInputElement>
    level: RefObject<HTMLInputElement>

    garden_size: RefObject<HTMLInputElement>

    substitute: RefObject<HTMLInputElement>
    time_alone_daily: RefObject<HTMLInputElement>

    cat_habitat: RefObject<HTMLInputElement>
    cat_sleeping_place: RefObject<HTMLInputElement>
    dog_habitat: RefObject<HTMLInputElement>
    dog_purpose: RefObject<HTMLInputElement>
}

export const WizardFormWrapper = FormContext<WizardFormContextData>([
    'name',
    'year',
    'profession',
    'knows_animals',
    'street_address',
    'locality',
    'region',
    'postal_code',
    'country',
    'move_in_date',
    'size',
    'level',
    'garden_size',
    'substitute',
    'time_alone_daily',
    'cat_habitat',
    'cat_sleeping_place',
    'dog_habitat',
    'dog_purpose',
])

type FamilyMemberFormContextData = {
    name: RefObject<HTMLInputElement>
    year: RefObject<HTMLInputElement>
    profession: RefObject<HTMLInputElement>
    knows_animals: RefObject<HTMLButtonElement>
    good_with_animals: RefObject<HTMLButtonElement>
    type: RefObject<HTMLInputElement>
    castrated: RefObject<HTMLButtonElement>
}

export const FamilyMemberFormWrapper = FormContext<FamilyMemberFormContextData>(
    [
        'name',
        'year',
        'profession',
        'knows_animals',
        'good_with_animals',
        'type',
        'castrated',
    ],
)

type ExperienceFormContextData = {
    type: RefObject<HTMLInputElement>
    animal_type: RefObject<HTMLInputElement>
    years: RefObject<HTMLInputElement>
    since: RefObject<HTMLInputElement>
}

export const ExperienceFormWrapper = FormContext<ExperienceFormContextData>([
    'type',
    'animal_type',
    'years',
    'since',
])
