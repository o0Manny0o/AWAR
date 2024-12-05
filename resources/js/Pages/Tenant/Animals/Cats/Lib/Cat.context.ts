import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

type CreateRefContextData = {
    name: RefObject<HTMLInputElement>
    breed: RefObject<HTMLInputElement>
    date_of_birth: RefObject<HTMLInputElement>
}

export const CreateCatFormWrapper = FormContext<CreateRefContextData>([
    'name',
    'breed',
    'date_of_birth',
])
