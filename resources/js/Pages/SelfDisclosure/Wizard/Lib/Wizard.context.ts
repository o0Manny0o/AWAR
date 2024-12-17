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
