import { createContext, RefObject } from 'react'

export const InputFocusContext = createContext<{
    [key: string]: RefObject<any>
}>({})
