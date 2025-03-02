export function ShowImages({
    images,
}: {
    images: (string | { file_url: string })[]
}) {
    return (
        <div className="flex gap-4 flex-wrap">
            {images?.map((image, index) => (
                <img
                    className="w-32 h-32 object-cover rounded-md"
                    alt={`gallery image ${index + 1}`}
                    key={index}
                    src={typeof image === 'string' ? image : image.file_url}
                />
            ))}
        </div>
    )
}
