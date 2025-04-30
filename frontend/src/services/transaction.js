import api from "../api";

export default {
    async getAll(){
        try {
            const response = await api.get('api/transaction/index')
            return response.data
        } catch (error) {
            console.error('Error fetching transactions:', error)
            throw error
        }
    }
}