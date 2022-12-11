import React, {useEffect} from 'react'
import {useForm, Controller} from 'react-hook-form'
import {useDispatch, useSelector} from 'react-redux'
import {fetchCategories} from '../../actions/categoryActions'
import {createSpot} from '../../actions/spotActions'
import Select from 'react-select'

const CreateSpot = () => {

    const { loading, categories, error } = useSelector(state => state.category);
    const dispatch = useDispatch()

    const onSubmit = (data) => {
        //console.log(JSON.stringify(data))
        dispatch(createSpot(data)).then((res) => {
            if (typeof res.error !== "undefined") {
                res.payload.violations.forEach(function(e){
                    setError(e.propertyPath, { type: e.code, message: e.message })
                })
            }
        });
    }

    const {
        register,
        formState: {
            errors,
            isValid,
        },
        handleSubmit,
        control,
        setError
    } = useForm({
        mode: "onBlur",
    });

    useEffect(() => {
        if (!loading && categories.length === 0) {
            dispatch(fetchCategories())
        }
    }, [])

    return (
        <div>
            <h1>Create Spot</h1>
            <form onSubmit={handleSubmit(onSubmit)}>
                <label>
                    Title:
                    <input type="text"
                           {...register("title", {
                               required: "Введите заголовок",
                           })}
                    />
                </label>
                <div>
                    {errors?.title && <p>{errors?.title?.message}</p>}
                </div>

                <label>
                    Slug:
                    <input type="text"
                           {...register("slug", {
                               required: "Введите slug",
                           })}
                    />
                </label>
                <div>
                    {errors?.slug && <p>{errors?.slug?.message}</p>}
                </div>

                {!loading ? (

                        <Controller
                            name="cats"
                            control={control}
                            rules={{ required: true }}
                            render={({ field }) => (
                                <Select {...field} isMulti options={categories.map(({ id, title }) => ({ value: id, label: title}))} />
                            )}
                        />

                ) : (
                    <div>Loading...</div>
                )}

                <div>
                    {errors?.cats && <p>{errors?.cats?.message}</p>}
                </div>

                <label>
                    Address:
                    <input type="text"
                           {...register("address", {
                               //required: "Введите address",
                           })}
                    />
                </label>
                <div>
                    {errors?.address && <p>{errors?.address?.message}</p>}
                </div>

                <label>
                    Description:
                    <input type="text"
                           {...register("description", {
                               //required: "Введите description",
                           })}
                    />
                </label>
                <div>
                    {errors?.description && <p>{errors?.description?.message}</p>}
                </div>


                <label>
                    Content:
                    <textarea
                           {...register("content", {
                               //required: "Введите content",
                           })}
                    />
                </label>
                <div>
                    {errors?.content && <p>{errors?.content?.message}</p>}
                </div>


                <label>
                    Lat:
                    <input type="text"
                           {...register("lat", {
                               //required: "Введите lat",
                           })}
                    />
                </label>
                <div>
                    {errors?.lat && <p>{errors?.lat?.message}</p>}
                </div>

                <label>
                    Lng:
                    <input type="text"
                           {...register("lat", {
                               //required: "Введите lat",
                           })}
                    />
                </label>
                <div>
                    {errors?.lat && <p>{errors?.lat?.message}</p>}
                </div>

                <label>
                    Is main?:
                    <checkbox {...register("main", {
                    })}/>
                </label>
                <div>
                    {errors?.lat && <p>{errors?.lat?.message}</p>}
                </div>


                <label>
                    Image:
                    <input type="file"
                           {...register("image", {
                               //required: "Введите description",
                           })}
                    />
                </label>
                <div>
                    {errors?.image && <p>{errors?.image?.message}</p>}
                </div>

                <input type="submit" disabled={!isValid}/>
            </form>
        </div>
    )
}

export default CreateSpot


