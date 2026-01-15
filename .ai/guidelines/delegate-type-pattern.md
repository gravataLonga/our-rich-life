# Delegate Type Pattern  

Two main concept of this pattern is to delegate specific data to a relation table. There a recordable and recording, which
is morph relationship where the recording only save data that is common to every recordable table, and recordable is the record
we want to record.  

Recording save recordable_type, recordable_id, parent_id, created_at, etc, basically is where metadata of recordable is saved.
Recordable is the data itself. 

## Example:

Recording Table

id: 1
recordable_type: App\Models\Bucket
recordable_id: 1
parent_id: null

Recordable Table
id: 1,
name: 'my bucket'

If we want to register Movements to recordable record Bucket, we fill parent_id in the recording table.  

## Immutability of Recordable  

Recordable are never deleted or updated, when need to update a Bucket record, we just create a new Bucket Recordable and in
the recording table we change the pointer to it. 
recordable_id: 1 -> recordable_id: 2  

With this it can recover past record or see all the change that happen to a certain recording.  

## Event's  

Is another concept that is related to delegate type, every time we need to create, update, or delete some recording, we keep track 
on event table when happend to what recording_id and to what recordable morph record.  

# Interact with Recordable  

In word to filter Recordable from Recording, you could use:  

<code-snippet name="Search or Filter Recording by Recordable" lang="php">
Recording::record(Bucket::class)->first();
</code-snippet>

To filter by Recordable and Parent id,

<code-snippet name="Search or Filter Recording by Recordable" lang="php">
Recording::record(Bucket::class, 1)->first();
</code-snippet>


