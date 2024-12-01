import { RefObject } from 'react'
import { ElementRefContext } from '@/shared/contexts/ElementRef.context'

type CreateRefContextData = {
    email: RefObject<HTMLInputElement>
    role: RefObject<HTMLInputElement>
}

export const FormInputRefs = ElementRefContext<CreateRefContextData>([
    'email',
    'role',
])
