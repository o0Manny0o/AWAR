import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'
import { AnimalFormContextData } from '@/Pages/Tenant/Animals/Lib/Animals.context'

type CatFormContextData = AnimalFormContextData & {
    breed: RefObject<HTMLInputElement>
}

export const CatFormWrapper = FormContext<CatFormContextData>([
    'name',
    'breed',
    'date_of_birth',
    'bio',
])
