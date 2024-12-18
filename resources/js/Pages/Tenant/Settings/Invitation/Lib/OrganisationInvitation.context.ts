import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

type CreateRefContextData = {
    email: RefObject<HTMLInputElement>
    role: RefObject<HTMLInputElement>
}

export const FormInputRefs = FormContext<CreateRefContextData>([
    'email',
    'role',
])
