import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

type WizardFormContextData = {
    name: RefObject<HTMLInputElement>
    age: RefObject<HTMLInputElement>
    profession: RefObject<HTMLInputElement>
    knows_animals: RefObject<HTMLButtonElement>
}

export const WizardFormWrapper = FormContext<WizardFormContextData>([
    'name',
    'age',
    'profession',
    'knows_animals',
])

type FamilyMemberFormContextData = {
    name: RefObject<HTMLInputElement>
    age: RefObject<HTMLInputElement>
    profession: RefObject<HTMLInputElement>
    knows_animals: RefObject<HTMLButtonElement>
    good_with_animals: RefObject<HTMLButtonElement>
    type: RefObject<HTMLInputElement>
    castrated: RefObject<HTMLButtonElement>
}

export const FamilyMemberFormWrapper = FormContext<FamilyMemberFormContextData>(
    [
        'name',
        'age',
        'profession',
        'knows_animals',
        'good_with_animals',
        'type',
        'castrated',
    ],
)
