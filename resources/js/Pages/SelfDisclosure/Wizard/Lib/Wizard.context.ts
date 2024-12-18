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
