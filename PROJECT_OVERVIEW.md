# Our Richer Life - Project Overview

Our Richer Life is a Laravel + Livewire application for tracking personal finance goals. It centers around "buckets" 
(financial goals) and "movements" (transactions) to show progress toward each goal and keep a lightweight audit trail of changes.

## What the app does
- Provides a dashboard where authenticated users can manage buckets (financial goals).
- Lets users add movements to each bucket to track contributions or adjustments.
- Supports snapshot movements to reconcile totals when needed.
- Records history through a generic recording/event system.

## Core concepts
- Bucket: A named goal with a target amount.
- Movement: A transaction applied to a bucket (positive or negative), with optional notes.
- Recording: A polymorphic wrapper that ties buckets and movements into a single timeline and parent/child structure.
- Event: A time-stamped log entry tied to a recording and its recordable entity.

## How it’s built
- Backend: Laravel 12 with Fortify for authentication and a custom Money value object.
- UI: Livewire 3 components for bucket lists, forms, and movement entries.
- Storage: Amounts are stored as integers (cents) and cast to Money for formatting and arithmetic.

## Main user flows
- Log in via Fortify.
- View the bucket list at `dashboard/buckets`.
- Create or edit a bucket using the bucket form.
- Open a bucket’s movements modal to add transactions or snapshots.
