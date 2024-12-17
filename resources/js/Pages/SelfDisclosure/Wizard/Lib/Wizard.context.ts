import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

type WizardFormContextData = {
    name: RefObject<HTMLInputElement>
    age: RefObject<HTMLInputElement>
    profession: RefObject<HTMLInputElement>
    knows: RefObject<HTMLButtonElement>
}

export const WizardFormWrapper = FormContext<WizardFormContextData>([
    'name',
    'age',
    'profession',
    'knows',
])

type FamilyMemberFormContextData = {
    name: RefObject<HTMLInputElement>
    age: RefObject<HTMLInputElement>
    profession: RefObject<HTMLInputElement>
    knows: RefObject<HTMLButtonElement>
    good_with_animals: RefObject<HTMLButtonElement>
    type: RefObject<HTMLInputElement>
    castrated: RefObject<HTMLButtonElement>
}

export const FamilyMemberFormWrapper = FormContext<FamilyMemberFormContextData>(
    [
        'name',
        'age',
        'profession',
        'knows',
        'good_with_animals',
        'type',
        'castrated',
    ],
)
