import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

type ListingFormContextData = {
    excerpt: RefObject<HTMLTextAreaElement>
    description: RefObject<HTMLTextAreaElement>
}

export const ListingFormWrapper = FormContext<ListingFormContextData>([
    'excerpt',
    'description',
])
