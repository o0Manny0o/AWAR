import { useContext } from 'react'
import { FormContextWrapper } from '@/shared/contexts/Form.context'

export default function useFormContext(
    wrapper: FormContextWrapper<any>,
    processing: boolean,
) {
    const { setProcessing, ...context } = useContext(wrapper.Context)

    setProcessing(processing)

    return {
        setProcessing,
        ...context,
    }
}
