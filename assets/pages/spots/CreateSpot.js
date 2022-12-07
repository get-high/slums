import React, {Component} from 'react'

export default class CreateSpot extends Component {

    createHandler = () => {

    }

    submitHandler = event => {
        event.preventDefault()
    }

    render () {
        return (
            <div>
                <h1>Create Spot</h1>
                <form onSubmit={this.submitHandler}>
                    <input type="text"/>
                    <input type="text"/>
                    <input type="text"/>
                    <input type="text"/>
                    <input type="text"/>
                    <button onClick={this.createHandler}>Добавить</button>
                </form>
            </div>
        )
    }
}


