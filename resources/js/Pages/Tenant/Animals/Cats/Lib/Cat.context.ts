import { RefObject } from 'react'
import { ElementRefContext } from '@/shared/contexts/ElementRef.context'

type CreateRefContextData = {
    name: RefObject<HTMLInputElement>
    breed: RefObject<HTMLInputElement>
    date_of_birth: RefObject<HTMLInputElement>
}

export const FormInputRefs = ElementRefContext<CreateRefContextData>([
    'name',
    'breed',
    'date_of_birth',
])
