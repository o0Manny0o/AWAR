type Join<
    Key,
    Previous,
    TKey extends number | string = string,
> = Key extends TKey
    ? Previous extends TKey
        ? `${Key}${'' extends Previous ? '' : '.'}${Previous}`
        : never
    : never

type Previous = [never, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, ...0[]]

type Paths<
    TEntity,
    TDepth extends number = 3,
    TKey extends number | string = string,
> = [TDepth] extends [never]
    ? never
    : TEntity extends object
      ? {
            [Key in keyof TEntity]-?: Key extends TKey
                ? `${Key}` | Join<Key, Paths<TEntity[Key], Previous[TDepth]>>
                : never
        }[keyof TEntity]
      : ''

type SetDataAction<TForm> = setDataByObject<TForm> &
    setDataByMethod<TForm> &
    setDataByKeyValuePair<TForm>

type setDataByObject<TForm> = (data: TForm) => void
type setDataByMethod<TForm> = (data: (previousData: TForm) => TForm) => void
type setDataByKeyValuePair<TForm> = <K extends keyof TForm>(
    key: K,
    value: TForm[K],
) => void
