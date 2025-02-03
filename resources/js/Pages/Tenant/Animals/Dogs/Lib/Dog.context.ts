import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

type CreateRefContextData = {
    name: RefObject<HTMLInputElement>
    breed: RefObject<HTMLInputElement>
    date_of_birth: RefObject<HTMLInputElement>
    family: RefObject<HTMLInputElement>
    bio: RefObject<HTMLInputElement>
}

export const DogFormWrapper = FormContext<CreateRefContextData>([
    'name',
    'breed',
    'family',
    'date_of_birth',
    'bio',
])
